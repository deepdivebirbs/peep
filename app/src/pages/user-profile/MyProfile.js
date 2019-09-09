import React from 'react';
import {httpConfig} from '../../../../app/src/shared/utils/http-config'
import {Container} from 'react-bootstrap';

export const MyProfile = () => {

	// grab the profile id from the currently logged in account, or null if not found
	const userProfileId = UseJwtProfileId();

	// Return the profile by profileId from the redux store
	const profile = useSelector(state => (state.profile ? state.profile[0] : []));
	console.log(profile);

	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getUserProfileById(match.params.userProfileId));
	};

	const inputs = [match.params.userProfileId];
	useEffect(effects, inputs);

	return (
		<>
			<Container>
				<h1>My Profile</h1>
				<div>
					<span>Username: {profile && profile.userProfileName}</span>
					<span>First Name: {profile && profile.userProfileFirstName}</span>
					<span>Last Name: {profile && profile.userProfileLastName}</span>
					<span>Email: {profile && profile.userProfileLastName}</span>
				</div>
			</Container>
		</>
	);
};

export default MyProfile;