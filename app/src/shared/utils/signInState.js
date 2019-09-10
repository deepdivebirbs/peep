export const getSignInState = () => {
	// if user is logged in return true
	if(window.localStorage.getItem("jwt-token") !== null) {
		return true;
	}
	// If user is NOT logged in return false
	return false;
};