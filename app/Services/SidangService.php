<?php

namespace App\Services;

use App\Models\SidangModel;
use App\Models\DosenModel;
use App\Models\DosenPengujiModel;
use App\Models\RuanganModel;
use Exception;

class SidangService
{
    protected $sidangModel;
    protected $dosenModel;
    protected $examinerModel;
    protected $roomModel;

    public function __construct()
    {
        $this->sidangModel = new SidangModel();
        $this->dosenModel = new DosenModel();
        $this->examinerModel = new DosenPengujiModel();
        $this->roomModel = new RuanganModel();
    }

    public function scheduleSidang(int $studentId): array
    {
        $lecturers = $this->dosenModel->findAll();
        $lecturerLoad = [];

        foreach ($lecturers as $lecturer) {
            $count = $this->examinerModel->where('id_dosen', $lecturer['id_dosen'])->countAllResults();
            $lecturerLoad[] = [
                'id_dosen' => $lecturer['id_dosen'],
                'count' => $count
            ];
        }

        usort($lecturerLoad, fn($a, $b) => $a['count'] <=> $b['count']);

        $examiner1 = $lecturerLoad[0]['id_dosen'] ?? null;
        $examiner2 = $lecturerLoad[1]['id_dosen'] ?? null;

        if (!$examiner1 || !$examiner2 || $examiner1 === $examiner2) {
            throw new Exception('Not enough available examiners.');
        }

        $startDate = strtotime('2026-01-01');
        $endDate = strtotime('+2 months', $startDate);
        $rooms = $this->roomModel->findAll();

        $roomUsage = [];

        foreach ($rooms as $room) {
            $count = $this->sidangModel
                ->where('id_ruangan', $room['id_ruangan'])
                ->countAllResults();
            $roomUsage[] = [
                'id_ruangan' => $room['id_ruangan'],
                'nama_ruangan' => $room['nama_ruangan'] ?? '', // Optional
                'count' => $count
            ];
        }

        // Urutkan ruangan berdasarkan jumlah penggunaan (prioritaskan yang paling sedikit dipakai)
        usort($roomUsage, fn($a, $b) => $a['count'] <=> $b['count']);


        $selectedDate = null;
        $startTime = null;
        $endTime = null;
        $selectedRoomId = null;
        $found = false;

        while ($startDate <= $endDate) {
            $dayOfWeek = date('N', $startDate);

            if ($dayOfWeek >= 6) {
                $startDate = strtotime('+1 day', $startDate);
                continue;
            }

            for ($hour = 8; $hour < 16; $hour++) {
                foreach ($roomUsage as $room) {
                    $date = date('Y-m-d', $startDate);
                    $start = sprintf('%02d:00:00', $hour);
                    $end = sprintf('%02d:00:00', $hour + 1);

                    $roomConflict = $this->sidangModel
                        ->where('tanggal_sidang', $date)
                        ->where('id_ruangan', $room['id_ruangan'])
                        ->groupStart()
                        ->where('waktu_mulai', $start)
                        ->orWhere('waktu_selesai', $start)
                        ->groupEnd()
                        ->countAllResults();

                    $examinerConflict = $this->examinerModel
                        ->whereIn('id_dosen', [$examiner1, $examiner2])
                        ->join('sidang', 'sidang.id_sidang = dosen_penguji.id_sidang')
                        ->where('tanggal_sidang', $date)
                        ->groupStart()
                        ->where('waktu_mulai', $start)
                        ->orWhere('waktu_selesai', $start)
                        ->groupEnd()
                        ->countAllResults();

                    if ($roomConflict === 0 && $examinerConflict === 0) {
                        $selectedDate = $date;
                        $startTime = $start;
                        $endTime = $end;
                        $selectedRoomId = $room['id_ruangan'];
                        $found = true;
                        break 3;
                    }
                }
            }

            $startDate = strtotime('+1 day', $startDate);
        }

        if (!$found) {
            throw new Exception('No available schedule found.');
        }

        $sidangData = [
            'id_mhs' => $studentId,
            'id_ruangan' => $selectedRoomId,
            'tanggal_sidang' => $selectedDate,
            'waktu_mulai' => $startTime,
            'waktu_selesai' => $endTime,
            'status' => 'DIJADWALKAN'
        ];

        $this->sidangModel->insert($sidangData);
        $newSidangId = $this->sidangModel->getInsertID();

        // Step 4: Insert examiners
        $this->examinerModel->insert([
            'id_sidang' => $newSidangId,
            'id_dosen' => $examiner1,
            'peran' => 'PENGUJI 1'
        ]);
        $this->examinerModel->insert([
            'id_sidang' => $newSidangId,
            'id_dosen' => $examiner2,
            'peran' => 'PENGUJI 2'
        ]);

        return [
            'message' => 'Defense scheduled successfully.',
            'id_sidang' => $newSidangId,
            'date' => $selectedDate,
            'time' => $startTime . ' - ' . $endTime,
            'room_id' => $selectedRoomId,
            'examiners' => [$examiner1, $examiner2]
        ];
    }
}
