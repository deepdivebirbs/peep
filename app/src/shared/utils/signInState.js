import {UseJwtUsername, UseJwtProfileId} from './jwtHelper';

export const getSignInState = () => {
	// if user is logged in return true
	console.log(UseJwtProfileId());
	if(UseJwtProfileId() !== null) {
		return true;
	}
	// If user is NOT logged in return false
	return false;
};