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
					<p>Photo</p>
				</div>
				<div>
					<p>Common Name</p>
				</div>
				<div>
					<p>Scientific Name</p>
				</div>
				<div>
					<p>Date</p>
				</div>
				<div>
					<p>Time</p>
				</div>
				<div>
					<p>Location</p>
				</div>
			</Container>
		</>
	);
}

