// require an #log element for log to print.
var debug = {
    // common part, require device plugin, battery-status plugin.
    log: undefined,
    line: undefined,
    init: function() {
        debug.log = document.getElementById('log');
    },
    printLine: function(text) {
        debug.line = document.createElement('p');
        debug.line.className = 'logline';
        debug.line.innerHTML = Date() + ':<br>' + text;
        debug.log.appendChild(debug.line);
        debug.log.scrollTop = debug.log.scrollHeight;
    },
    printImg: function(url, msg) {
        debug.line = document.createElement('div');
        debug.line.className = 'logline';
        debug.log.appendChild(debug.line);

        var img = document.createElement('img');
        img.onload = function(){
            if (debug.line.clientWidth > img.naturalWidth) {
                img.width = img.naturalWidth;
            } else {
                img.width = debug.line.clientWidth;
            }
            debug.log.scrollTop = debug.log.scrollHeight;
        };
        img.src = url;
        
        var time_node = document.createElement('p');
        time_node.innerHTML = Date();
        debug.line.appendChild(time_node);
        if (msg) {
            var msg_node = document.createElement('p');
            msg_node.innerHTML = msg;
            debug.line.appendChild(msg_node);
        }
        debug.line.appendChild(img);
        debug.log.scrollTop = debug.log.scrollHeight;
    },
    printImgBase64: function(data, msg) {
        debug.printImg('data:image/png;base64,' + data, msg);
    }
};

