
		var theses = [{thesis:"Het is belangrijk dat alle kolencentrales zo snel mogelijk worden vervangen/gesloten.",
						scores: [
							[-3,-1,3], //D66 NO/NEUTRAL/YES
							[-1,0,2], //50Plus
							[3,0,-3]  //PVV
						],
						response: null
					},

						{thesis:"We moeten zelfstandiger worden, los van de EU.",
						 scores: [
							[3,0,-2], //D66 NO/NEUTRAL/YES
							[2,1,-1], //50Plus
							[-3,-1,3] //PVV
						],
						response: null
					},
						{thesis:"De AOW leeftijd moet terug naar 65 jaar oud.",
						 scores: [
						 	[2,0,-3], //D66 NO/NEUTRAL/YES
						 	[-3,-1,3],//50Plus
						 	[-2,0,2]  //PVV
						 ],
						 response: null
					}];

		var parties = [
			{party:'D66', score:0},
			{party:'50Plus', score:0},
			{party:'PVV', score:0}
			];

		var i = 0; // Current Question in array Theses

		function pollQuestion(pollInput) {

			for (var p = 0; p <= theses[0]['scores'].length - 1; p++) {
				var mod = theses[i]['scores'][p][pollInput];
				parties[p]['score'] = parties[p]['score'] + mod;
			}

			//console.log(parties);

			if(i == 2){
				document.getElementById("thesis").style.display = "none";
				document.getElementById("result").style.display = "block";
				document.getElementById("D66_Result").innerHTML = parties[0]['score'];
				document.getElementById("50Plus_Result").innerHTML = parties[1]['score'];
				document.getElementById("PVV_Result").innerHTML = parties[2]['score'];
			} else{
				i++;
				document.getElementById("pollQ").innerHTML = theses[i]['thesis'];
			}
		}
