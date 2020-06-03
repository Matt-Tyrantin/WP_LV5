const SIDE_ID_1 = '#firstSide';
const SIDE_ID_2 = '#secondSide';

var fighterNodes = {};
fighterNodes[SIDE_ID_1] = document.querySelectorAll('#firstSide .fighter-box');
fighterNodes[SIDE_ID_2] = document.querySelectorAll('#secondSide .fighter-box');

var fighterChosen = {};
var sideChosen = {};
sideChosen[SIDE_ID_1] = false;
sideChosen[SIDE_ID_2] = false;

var randomButton = document.querySelector('button#randomFight');
var fightButton = document.querySelector('button#generateFight');
fightButton.disabled = true;

function getOppositeSideId(sideId) {
	if (sideId == SIDE_ID_1)
		return SIDE_ID_2;
	
	if (sideId == SIDE_ID_2)
		return SIDE_ID_1;

	return null;
}

function deselectFighter(fighterNode) {
	fighterNode.querySelector('img').style.border = 'none';
}

function selectFighter(fighterNode) {
	let sideId = '#' + fighterNode.closest('div[id]').getAttribute('id');

	let infoNode = document.querySelector(sideId + ' .cat-info');
	let imgNode = document.querySelector(sideId + ' .featured-cat-fighter-image');

	let catInfo = JSON.parse(fighterNode.getAttribute('data-info'));
	let catImg = fighterNode.querySelector('img');
	let oppositeNode = fighterNodes[getOppositeSideId(sideId)][catInfo.id - 1];

	updateInfoNode(infoNode, catInfo);

	imgNode.src = catImg.src;

	fighterChosen[sideId] = catInfo;
	sideChosen[sideId] = true;

	for (let node of fighterNodes[getOppositeSideId(sideId)]) {
		enableFighter(node);
	}
	disableFighter(oppositeNode);

	for (let node of fighterNodes[sideId]) {
		deselectFighter(node);
	}

	fighterNode.querySelector('img').style.border = 'solid 10px';
}

function enableFighter(fighterNode) {
	fighterNode.disabled = false;
	fighterNode.querySelector('img').style.opacity = 1;
}

function disableFighter(fighterNode) {
	fighterNode.disabled = true;
	fighterNode.querySelector('img').style.opacity = 0.3;
}

function updateSelection() {
	for (let sideId in fighterNodes) {
		for (let node of fighterNodes[sideId]) {
			let catInfo = JSON.parse(node.getAttribute('data-info'));
			if (catInfo.id != fighterChosen[getOppositeSideId(sideId)].id) {
				enableFighter(node);
			}
		}

		let infoNode = document.querySelector(sideId + ' .cat-info');

		updateInfoNode(infoNode, fighterChosen[sideId]);
	}
}

function updateInfoNode(infoNode, fighterInfo) {
	infoNode.querySelector('li.name').innerHTML = fighterInfo.name;
	infoNode.querySelector('li.age').innerHTML = fighterInfo.age;
	infoNode.querySelector('li.skills').innerHTML = fighterInfo.catInfo;
	infoNode.querySelector('li.record').innerHTML = 'Wins: ' + fighterInfo.record.wins + ' Loss: ' + fighterInfo.record.loss;
}

function selectRandom() {
	let r1 = 0;
	let r2 = 0;

	while (r1 == r2) {
		r1 = Math.floor(Math.random() * Math.floor(6));
		r2 = Math.floor(Math.random() * Math.floor(6));
	}

	selectFighter(fighterNodes[SIDE_ID_1][r1]);
	selectFighter(fighterNodes[SIDE_ID_2][r2]);
	fighterSelected();
}

function calculateFight(fighter1, fighter2) {
	let wr1 = fighter1.record.wins/ (fighter1.record.wins + fighter1.record.loss);
	let wr2 = fighter2.record.wins/ (fighter2.record.wins + fighter2.record.loss);

	let advantage = 0.1;

	if (wr2 > wr1) {
		advantage *= -1;
	}

	if (Math.abs(wr2 - wr1) >= 0.1) {
		advantage *= 2;
	}

	if(Math.random() <= 0.5 + advantage) {
		return {'winner': fighter1, 'loser': fighter2};
	} else {
		return {'winner': fighter2, 'loser': fighter1};
	}
}

function fight() {
	let fighter1 = fighterChosen[SIDE_ID_1];
	let fighter2 = fighterChosen[SIDE_ID_2];

	for (sideId in fighterNodes) {
		for (node of fighterNodes[sideId]) {
			disableFighter(node);
		}
	}

	let messageBox = document.createElement('p');
	messageBox.innerHTML = '3';

	document.querySelector('section.container').appendChild(messageBox);

	setTimeout(function () { 
		messageBox.innerHTML = '2'; 
		setTimeout(function() {
			messageBox.innerHTML = '1';
			setTimeout(function() {
				let imgNode1 = document.querySelector(SIDE_ID_1 + ' .featured-cat-fighter-image');
				let imgNode2 = document.querySelector(SIDE_ID_2 + ' .featured-cat-fighter-image');
				let result = calculateFight(fighter1, fighter2);

				//window.location = 'simulation_end.php?winner=' + result.winner.id + '&loser=' + result.loser.id;

				let xhr = new XMLHttpRequest();
				xhr.open('POST', 'simulation_end.php', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.send('winner=' + result.winner.id + '&loser=' + result.loser.id);

				result.winner.record.wins += 1;
				result.loser.record.loss += 1;

				fighterNodes[SIDE_ID_1][result.winner.id - 1].setAttribute('data-info', JSON.stringify(result.winner));
				fighterNodes[SIDE_ID_2][result.winner.id - 1].setAttribute('data-info', JSON.stringify(result.winner));
				fighterNodes[SIDE_ID_1][result.loser.id - 1].setAttribute('data-info', JSON.stringify(result.loser));
				fighterNodes[SIDE_ID_2][result.loser.id - 1].setAttribute('data-info', JSON.stringify(result.loser));

				if (result.winner.id == fighter1.id) {
					imgNode1.style.border = 'solid green 6px';
					imgNode2.style.border = 'solid red 6px';
				} else {
					imgNode1.style.border = 'solid red 6px';
					imgNode2.style.border = 'solid green 6px';
				}
				
				messageBox.innerHTML = 'Winner is ' + result.winner.name + '!!';

				updateSelection();

				setTimeout(function() {
					messageBox.remove();
				}, 4000);
			}, 1000);
		}, 1000);
	}, 1000);
}

function fighterSelected() {
	let allSidesChosen = true;

	for (let sideId in sideChosen) {
		allSidesChosen = allSidesChosen && sideChosen[sideId];
	}

	if (allSidesChosen) {
		fightButton.disabled = false;
	}
}

for (let sideId in fighterNodes) {
	Array.from(fighterNodes[sideId]).forEach(fighterNode => {
		fighterNode.addEventListener('click', function () { 
			if (this.disabled) {
				return;
			}

			selectFighter(this);
			fighterSelected();
		});
	});
}

fightButton.addEventListener('click', fight);
randomButton.addEventListener('click', selectRandom);