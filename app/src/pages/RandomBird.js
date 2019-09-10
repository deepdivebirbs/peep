import React from 'react';
import Iframe from 'react';
import {useDispatch, useSelector} from "react-redux";
import {getAllSpecies} from "../shared/actions/species";
import {useEffect} from "react";
import {Button, Card} from "react-bootstrap";
import BirdCard from '../shared/components/BirdCard';



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

	return(
		<>
			<BirdCard title={bird.birdComName} birdInfo={bird.birdSciName} image={bird.birdPhotoUrl}/>
		</>
	);
};

export default RandomBird;
