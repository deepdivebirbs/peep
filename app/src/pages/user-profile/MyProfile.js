import React, {useEffect} from 'react';
import {Container} from 'react-bootstrap';
import {useSelector, useDispatch} from "react-redux";
import {getUserProfileById} from "../../shared/actions/myProfile";
import {UseJwtProfileId} from "../../shared/utils/jwtHelper2";

export const MyProfile = ({match}) => {

	const USER = useSelector(state => state.userProfile ? state.userProfile : []);

	// grab the profile id from the currently logged in account, or null if not found
	const userProfileId = UseJwtProfileId();

	// Return the profile by profileId from the redux store
	const profile = useSelector(state => (state.profile ? state.profile[0] : []));
	console.log(profile);

	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getUserProfileById(match.param.userProfileId));
	};

	const inputs = [match.param.userProfileId];
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