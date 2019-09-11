export const getSignInState = () => {
	// if user is logged in return true
	if(window.localStorage.getItem("jwt-token") !== null) {
		console.log(window.localStorage.getItem("jwt-token"));
		return true;
	}
	console.log("Signed Out");
	// If user is NOT logged in return false
	return false;
};