import React, {useState} from 'react';
import {httpConfig} from "../../../src/shared/utils/http-config";
import MyProfileFormContent from './MyProfileFormContent';
import * as Yup from "yup";
import {Formik} from "formik";

export const MyProfileForm = () => {
	let profile = {
		userProfileName: "",
		userProfileFirstName: "",
		userProfileLastName: "",
		userProfileEmail: ""
	}
};

const validator = Yup.object().shape({
	userProfileName: Yup.string()
		.required("You must have a valid username"),

	userProfileFirstName: Yup.string()
		.required("Please list a valid name."),

	userProfileLastName: Yup.string()
			.required("Please list a valid name."),

	userProfileEmail: Yup.string().email()
			.required("You must have a valid email.")
});

export default MyProfileForm();