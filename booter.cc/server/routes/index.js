const fs = require('fs');
const path = require('path');

module.exports = (app, socket, broadcast, socketsInfo) => {
  // API routes
  fs.readdirSync(__dirname).forEach( (dir) => {
    if(!dir.endsWith('.js'))
      fs.readdirSync(__dirname + `/${dir}`).forEach((file) => {
        require(`./${dir}/${file.substr(0, file.indexOf('.'))}`)(app, socket, broadcast, socketsInfo);
      });
  })
};