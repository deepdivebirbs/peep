import React, {useEffect} from 'react';
import {Container} from 'react-bootstrap';
import {useSelector, useDispatch} from "react-redux";
import {getSightingsBySightingUserProfileId} from "../../shared/actions/birdSpeciesSighting";
import {getSpeciesBySpeciesId} from "../../shared/actions/species";

export const MySightings = () => {

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
				<div className="jumbotron p-3 mt-5 justify-content-end transparent">
				<h1><strong>My Most Recent Sighting</strong></h1><br/>
					<div>
					<h3>Photo: {sightings && sightings.sightingBirdPhoto}</h3><br/>
					<h3>Common Name: {sightings && birdSpecies.birdComName}</h3><br/>
					<h3>Scientific Name: {sightings && birdSpecies.birdSciName}</h3><br/>
					<h3>Date: {sightings && sightings.sightingDate}</h3><br/>
					<h3>Time: {sightings && sightings.sightingTime}</h3><br/>
					<h3>Location: {sightings && sightings.sightingLocation}</h3><br/>
					</div>
				</div>
			</Container>
		</>
	);
};

export default MySightings;
