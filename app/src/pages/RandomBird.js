import React from 'react';
import Iframe from 'react';
import {useDispatch, useSelector} from "react-redux";
import {getAllSpecies} from "../shared/actions/species";
import {useEffect} from "react";
import {Button, Card} from "react-bootstrap";



export const RandomBird = () => {
	const BIRDS = useSelector(state => state.species ? state.species : []);
	const DISPATCH = useDispatch();

	const sideEffects = () => {
		DISPATCH(getAllSpecies());
	};

	const sideEffectInputs = [];

	useEffect(sideEffects, sideEffectInputs);

	function getRandomBird(birdArray) {
		let rand = Math.floor((Math.random() * birdArray.length) + 1);
		return(birdArray[rand]);
	}

	let randomBird = getRandomBird(BIRDS);

	let bird = {
		birdComName: randomBird ? randomBird.speciesComName : "",
		birdSciName: randomBird ? randomBird.speciesSciName : "",
		birdPhotoUrl: randomBird ? randomBird.speciesPhotoUrl : ""
	};

	console.log(randomBird);

	return(
		<Card className={"dailyFeature"} style={{width: '18rem'}}>
			<Card.Img variant="top" src={bird.birdPhotoUrl} alt={bird.birdPhotoUrl}/>
			<Card.Body>
				<Card.Title>Bird of the Day</Card.Title>
				<span>Species Common Name:</span>
				<p>{bird.birdComName}</p>

				<span>Species Scientific Name:</span>
				<p>{bird.birdSciName}</p>

				<Button variant="primary">View Sightings</Button>
			</Card.Body>
		</Card>
	);
};

export default RandomBird;
