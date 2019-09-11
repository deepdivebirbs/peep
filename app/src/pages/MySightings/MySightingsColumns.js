import React, {useEffect} from 'react';
import BirdCard from '../../shared/components/BirdCard';
import {useDispatch, useSelector} from "react-redux";
import {getSpeciesBysightingBirdSpeciesId} from "../../shared/actions/birdSpeciesSighting";
import {getAllSpecies, getSpeciesBySpeciesId} from "../../shared/actions/species";
import {Col} from 'react-bootstrap';

export const MySightingsColumns = (props) => {
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
	console.log(BIRDS);
	let bird = {
		birdComName: randomBird ? randomBird.speciesComName : "",
		birdSciName: randomBird ? randomBird.speciesSciName : "",
		birdPhotoUrl: randomBird ? randomBird.speciesPhotoUrl : ""
	};

	let mappedSighting = BIRDS.map(function(bird){
		return(
			<BirdCard commonName={bird.speciesComName} sciName={bird.speciesSciName}/>
		);
	});
	return (
		<>
			<Col>
				{mappedSighting}
			</Col>
		</>
	);
};

export default MySightingsColumns;