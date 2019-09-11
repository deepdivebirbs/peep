import React, {useEffect} from 'react';
import {Container} from 'react-bootstrap';
import {useSelector, useDispatch} from "react-redux";
import {getUserProfileById} from "../../shared/actions/myProfile";
import {UseJwtUserProfileId} from "../../shared/utils/jwtHelper2";

export const MyProfile = ({match}) => {

	// grab the profile id from the currently logged in account, or null if not found
	const userProfileId = UseJwtUserProfileId();

	// Return the profile by profileId from the redux store
	const profile = useSelector(state => (state.userProfile ? state.userProfile[0] : []));
	console.log(profile);

	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getUserProfileById(match.params.userProfileId));
	};

 	const inputs = [match.params.userProfileId];
	useEffect(effects, inputs);

	console.log(userProfileId);

	return (
		<>
			<Container>
				<div className="jumbotron mt-4 col-6 justify-content-end">
					<h1>My Profile</h1><br/>
					<div>
						<h3 id="profile-card-text">Username: {profile && profile.userProfileName}</h3><br/>
						<h3 id="profile-card-text">First Name: {profile && profile.userProfileFirstName}</h3><br/>
						<h3 id="profile-card-text">Last Name: {profile && profile.userProfileLastName}</h3><br/>
						<h3 id="profile-card-text">Email: {profile && profile.userProfileEmail}</h3>
					</div>
				</div>
			</Container>
		</>
	);
};

export default MyProfile;