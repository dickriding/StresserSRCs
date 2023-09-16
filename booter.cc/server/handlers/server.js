const { readdirSync } = require('fs');

module.exports = (server) => {
	const events = readdirSync(`./events/`).filter(d => d.endsWith('.js'));
	for(let file of events) {
        const evt = require (`../events/${file}`);
        let eName = file.split('.')[0];
        server.on(eName, evt.bind(null,server));

    }
}