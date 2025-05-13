const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const cors = require('cors');

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
  cors: {
    origin: '*', 
    methods: ['GET', 'POST']
  }
});

app.use(cors());
app.use(express.json());


app.post('/notify', (req, res) => {
  const notif = req.body;

  console.log('Notifikasi diterima dari backend:', notif);

  io.emit('notification', notif);

  res.status(200).send({ status: 'success', message: 'Notifikasi terkirim' });
});

io.on('connection', (socket) => {
  console.log('Client terhubung:', socket.id);

  socket.on('disconnect', () => {
    console.log('Client disconnect:', socket.id);
  });
});

const PORT = 3000;
server.listen(PORT, () => {
  console.log(`Socket.IO server jalan di http://localhost:${PORT}`);
});
