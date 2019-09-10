import React, {useEffect} from 'react';
import {Container} from 'react-bootstrap';
import {useSelector, useDispatch} from "react-redux";
import {getSightingsBySightingUserProfileId} from "../../shared/actions/birdSpeciesSighting";
import {getSpeciesBySpeciesId} from "../../shared/actions/species";

export const Sighting = () => {

	// grab the profile id from the currently logged in account, or null if not found
	//const userProfileId = UseJwtProfileId();

	// Return the profile by profileId from the redux store
	const sightings = useSelector(state => state.sighting ? [...state.sighting] : []);
	const birdSpecies = useSelector(state => state.species ? {...state.species} : null);
	//const sighting = useSelector(state => (state.birdSpeciesSightings ? state.sighting[0] : []));

	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getSightingsBySightingUserProfileId());
		dispatch(getSpeciesBySpeciesId());
	};

	const inputs = [];
	useEffect(effects, inputs);

	return (
		<>
			<Container>
				<h1>Sighting</h1>
				<div>
					<span>Photo: {sightings && sightings.sightingBirdPhoto}</span>
				</div>
				<div>
					<span>Common Name: {sightings && birdSpecies.birdComName}</span>
				</div>
				<div>
					<span>Scientific Name: {sightings && birdSpecies.birdSciName}</span>
				</div>
				<div>
					<span>Date: {sightings && sightings.sightingDate}</span>
				</div>
				<div>
					<p>Time: {sightings && sightings.sightingTime}</p>
				</div>
				<div>
					<span>Location: {sightings && sightings.sightingLocation}</span>
				</div>
			</Container>
		</>
	);
};

export default Sighting;