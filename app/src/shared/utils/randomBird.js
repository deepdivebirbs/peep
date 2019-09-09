export function getRandomBird(birdArray) {
	let rand = Math.floor((Math.random() * birdArray.length) + 1);
	return birdArray[rand];
}

