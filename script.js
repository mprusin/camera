function strzalka (par1){
	//document.write(par1);
	if (par1 == "down"){
		return '<img src="image/\smile1.gif" width="50" height="59" alt="Better"//>';
	} else if (par1 == "up") {
		return '<img src="image/\OK1.gif" width="40" height="49" alt="OK"//>';
	} else if (par1 == "-") {
		return '<img src="image/\zly1.gif" width="40" height="49" alt="Worse"//>';
	}
}

function countdown(targetDate, displayElement, onCountdownFinish ) {
	if (!(targetDate && displayElement)) {
	return;
	}
	var formatTimeInterval = function(seconds) {
	var hrs = Math.floor(seconds / 3600)
	var min = Math.floor(seconds / 60) % 60;
	var sec = seconds % 60;
	return (hrs + ':' + min + ':' + sec).replace(/(^|:)(\d)(?=:|$)/g, '$10$2');
	};

	var refreshTimer = function() {
	var now = new Date();
	var diffMilliseconds = targetDate.getTime() - now.getTime();
	var diffSeconds = Math.round(diffMilliseconds / 1000);
	if (diffSeconds < 0) {
	  diffSeconds = 0;
	}
	var countdownHTML = formatTimeInterval(diffSeconds)
	if (countdownHTML != displayElement.innerHTML) {
	  displayElement.innerHTML = countdownHTML;
	}
	if (diffSeconds === 0) {
	  clearInterval(intervalId);
	  if (typeof onCountdownFinish === 'function') {
		onCountdownFinish(targetDate);
	  }
	}
	};
	var intervalId = setInterval(refreshTimer, 250);
	refreshTimer();
}

function newDate(czas){
	var now = new Date();
	var plusIle = czas.split(':');
	var plusIle1 = (parseInt(plusIle[0]) * 3600 + parseInt(plusIle[1]) * 60 + parseInt(plusIle[2]))*1000;
		 
	return(new Date(now.getTime() + plusIle1));		 
}