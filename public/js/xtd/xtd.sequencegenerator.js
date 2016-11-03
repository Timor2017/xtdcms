try {
	window.XTD.SequenceGenerator = window.XTD.SequenceGenerator || (function () {
		var counter = 0;
		return {
			getNextCounter: function () {
				return ++counter;
			}
		}
	})();
}  catch (e) {
	console.log(e);
}