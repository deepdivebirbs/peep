import React, {useState} from 'react';
import {httpConfig} from "../../../src/shared/utils/http-config";
import LogInFormContent from './LogInFormContent';
import * as Yup from "yup";
import {Formik} from "formik";

export const LogInForm = () => {
	let logIn = {
		userProfileEmail: "",
		userProfilePassword: ""
	};

	let validator = Yup.object().shape({
		userProfileEmail: Yup.string()
			.required("Email is required to sign in.")
			.email("Must be a valid email."),
		userProfilePassword: Yup.string()
			.required("Enter you password to log in.")
			.min(8, "Password must be at least 8 characters.")
	});

	const signInSubmit = (values, {resetForm, setStatus}) => {
		httpConfig.post("/apis/sign-in/", values)
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					resetForm();
					setStatus({message, type});
				}
				setStatus({message, type});
			});
	};

	return(
		<Formik onSubmit={signInSubmit} initialValues={logIn} validationSchema={validator}>
			{LogInFormContent}
		</Formik>
	);
};

export default LogInForm;