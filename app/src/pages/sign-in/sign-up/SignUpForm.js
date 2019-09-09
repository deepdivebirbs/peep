import React, {useState} from 'react';
import {httpConfig} from "../../../shared/utils/http-config";
import SignUpFormContent from './SignUpFormContent';
import * as Yup from "yup";
import {Formik} from "formik";

export const SignUpForm = () => {

	const [status, setStatus] = useState(null);

	const signUp = {
		userFirstName: "",
		userLastName: "",
		profileUsername: "",
		userProfileEmail: "",
		userProfilePassword: "",
		userProfilePasswordConfirm: ""
	};

	const validator = Yup.object().shape({
		userFirstName: Yup.string()
			.required ("First name is required"),
		userLastName: Yup.string()
			.required ("Last name is required"),
		profileUsername: Yup.string()
			.required("User name is required.")
			.min(3, "User name must be at least 3 characters."),
		userProfileEmail: Yup.string()
			.required("Email is a required field.")
			.email("Please enter a valid email."),
		userProfilePassword: Yup.string()
			.required("You must enter a password.")
			.min(8, "Password must be at least 8 characters."),
		userProfilePasswordConfirm: Yup.string()
			.required("You must confirm your password.")
			.min(8, "Password must be at least 8 characters.")
	});

	const signUpSubmit = (values, {resetForm, setStatus}) => {
		httpConfig.post('/apis/sign-up/', values)
			.then(reply => {
				let {message, type} = reply;
				setStatus ({message, type});
				if(reply.status === 200) {
					resetForm();
					setStatus({message, type});
				}
			});
	};

	return (
		<>
			<Formik
				initialValues={signUp}
				onSubmit={signUpSubmit}
				validationSchema={validator}
			>
				{SignUpFormContent}
			</Formik>

		</>
	);
};

export default SignUpForm;