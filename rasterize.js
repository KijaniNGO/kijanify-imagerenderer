var page = require('webpage').create(),
	system = require('system'),
	address, output, qual;

if (system.args.length < 3 || system.args.length > 4 ) {
	console.log('Wrong number of arguments!');
	console.log('Usage: rasterize.js URL filename [quality]');
	phantom.exit(1);
} else {
	address = system.args[1];
	output = system.args[2];
	page.viewportSize = { width: 1, height: 1 };
	qual = system.args.length == 4 ? system.args[3] : '80';
	page.open(address, function (status) {
		if (status !== 'success') {
			console.log('Unable to load the address!');
			phantom.exit(1);
		} else {
			window.setTimeout(function () {
				page.render(output, {quality: qual});
				phantom.exit();
			}, 200);
		}
	});
}