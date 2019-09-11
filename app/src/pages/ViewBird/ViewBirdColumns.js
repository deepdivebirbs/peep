// Written by Mark Waid Jr

import React, {useEffect} from 'react';
import {Col} from 'react-bootstrap';
import {useDispatch, useSelector} from "react-redux";
import {getAllSpecies} from "../../shared/actions/species";
import BirdCard from '../../shared/components/BirdCard';

export const ViewBirdColumn = ({props}) => {
	const BIRDS = useSelector(state => state.species ? state.species : []);
	const DISPATCH = useDispatch();

	const sideEffects = () => {
		DISPATCH(getAllSpecies());
	};

	const sideEffectInputs = [];

	useEffect(sideEffects, sideEffectInputs);

	let mappedBird = BIRDS.map(function(bird){
		return(
			<BirdCard commonName={bird.speciesComName} sciName={bird.speciesSciName}/>
		);
	});

	return (
		<>
			{mappedBird}
		</>
	);
};

export default ViewBirdColumn;