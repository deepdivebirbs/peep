import React from 'react';
import {httpConfig} from '../../../../app/src/shared/utils/http-config'
import {Container} from 'react-bootstrap';

export const ShowSighting = () => {

	// grab the profile id from the currently logged in account, or null if not found
	//const userProfileId = UseJwtProfileId();

	// Return the profile by profileId from the redux store
	const profile = useSelector(state => (state.profile ? state.profile[0] : []));
	console.log(profile);

	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getSightingsBySightingUserProfileId(match.params.sightingUserProfileId));
	};

	const inputs = [match.params.sightingUserProfileId];
	useEffect(effects, inputs);

	return (
		<>
			<Container>
				<h1>Sighting</h1>
				<div>
					<span>Photo: {sighting && sighting.sightingBirdPhoto}</span>
				</div>
				<div>
					<span>Common Name: /*{aspecies && species.comName}*/</span>
				</div>
				<div>
					<span>Scientific Name: /*{species && species.sciName}*/</span>
				</div>
				<div>
					<span>Date: {sighting && sighting.sightingDate}</span>
				</div>
				<div>
					<p>Time: {sighting && sighting.sightingTime}</p>
				</div>
				<div>
					<span>Location: {sighting && sighting.sightingLocation}</span>
				</div>
			</Container>
		</>
	);
};

export default ShowSighting;