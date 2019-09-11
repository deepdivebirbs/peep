import React, {useEffect} from 'react';
import {Col} from 'react-bootstrap';
import {useDispatch, useSelector} from "react-redux";
import {getAllSpecies} from "../../shared/actions/species";
import BirdCard from '../../shared/components/BirdCard';

export const ViewBirdColumn = () => {
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

	console.log(BIRDS);

	for(let i in BIRDS) {
		return (
			<>
				<Col>
					<BirdCard commonName={BIRDS[i]} sciName={BIRDS[i]}/>
				</Col>
			</>
		);
	}
};

export default ViewBirdColumn;