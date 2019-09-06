import React, {useState} from 'react';
import {httpConfig} from "../../../src/shared/utils/http-config";
import SignUpFormContent from './SignUpFormContent';
import * as Yup from "yup";
import {Formik} from "formik";

export const SignUpForm = () => {
	let signUp = {
		firstName: "Johny",
		lastName: "Appleseed",
		username: "JApples",
		email: "johnny@appleseed.com",
		password: "Password",
		passwordConfirm: "Password Confirm"
	};

	const [status, setStatus] = useState(null);

	const validator = Yup.object.shape({
		firstName: Yup.string(),
		lastName: Yup.string(),
		username: Yup.string()
			.required("User name is required.")
			.min(3, "Password must be at least 3 characters."),
		email: Yup.string()
			.required("Email is a required field.")
			.email("Please enter a valid email."),
		password: Yum.string()
			.required("A password must be entered.")
			.min(8, "Password must be at least 8 characters."),
		passwordConfirm: Yum.string()
			.required("You must confirm you password.")
			.min(8)
	});

	const signUpSubmit = (values, {resetFrom}) => {
		httpConfig.post('/apis/sign-up')
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200) {
					resetFrom();
				}
			});
	};

	return(
		<Formik onSubmit={signUpSubmit} initialValues={signUp} validationSchema={validator}>
			{SignUpFormContent}
		</Formik>
	);
};