import React, {useState, useEffect} from "react";
import * as jwtDecode from "jwt-decode";

/*
* Custom hooks to grab the jwt and decode jwt data for logged in users.
*
* Author: rlewis37@cnm.edu
* */

export const UseJwt = () => {
	const [jwt, setJwt] = useState(null);

	useEffect(() => {
		setJwt(window.localStorage.getItem("jwt-token"));
	});

	return jwt;
};

export const UseJwtUserProfileName = () => {
	const [userProfileName, setUserProfileName] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setUserProfileName(decodedJwt.auth.userProfileName);
		}
	});

	return userProfileName;
};

export const UseJwtUserProfileId = () => {
	const [userProfileId, setUserProfileId] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setUserProfileId(decodedJwt.auth.userProfileId);
		}
	});

	return userProfileId;
};