import React, {useState} from 'react';
import {Redirect} from "react-router";
import {httpConfig} from "../../../src/shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {LogInFormContent} from "./LogInFormContent"

export const LogInForm = () => {

	// Set initial values
	let logIn = {
		userProfileEmail: "",
		userProfilePassword: ""
	};

	// Validate form input
	let validator = Yup.object().shape({
		userProfileEmail: Yup.string()
			.required("Email is required to sign in.")
			.email("Must be a valid email."),
		userProfilePassword: Yup.string()
			.required("Enter your password to log in.")
	});

	const logInSubmit = (values, {resetForm, setStatus}) => {
		httpConfig.post("/apis/sign-in/", values)
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200 && reply.headers ["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers ["x-jwt-token"]);
					resetForm();
					setStatus({message, type});
				}
				setStatus({message, type});
			});
	};

	return(
		<>
		<Formik
			initialValues={logIn}
			onSubmit={logInSubmit}
			validationSchema={validator}
		>
			{LogInFormContent}
		</Formik>
		</>
	)
};

export default LogInForm;