import React, {useState} from 'react';
import {httpConfig} from "../../../src/shared/utils/http-config";
import SignUpFormContent from './SignUpFormContent';
import * as Yup from "yup";
import {Formik} from "formik";

export const SignUpForm = () => {
	let signUp = {
		userFirstName: "",
		userLastName: "",
		profileUsername: "",
		userProfileEmail: "",
		userProfilePassword: "",
		userProfilePasswordConfirm: ""
	};

	const [status, setStatus] = useState(null);

	const validator = Yup.object().shape({
		userFirstName: Yup.string(),
		userLastName: Yup.string(),
		profileUsername: Yup.string()
			.required("User name is required.")
			.min(3, "Password must be at least 3 characters."),
		userProfileEmail: Yup.string()
			.required("Email is a required field.")
			.email("Please enter a valid email."),
		userProfilePassword: Yup.string()
			.required("A password must be entered.")
			.min(8, "Password must be at least 8 characters."),
		userProfilePasswordConfirm: Yup.string()
			.required("You must confirm you password.")
			.min(8)
	});

	const signUpSubmit = (values, {resetFrom}) => {
		httpConfig.post('/apis/sign-up/', values)
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200) {
					console.log(values);
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

export default SignUpForm;