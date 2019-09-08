import React, {useState} from 'react';
import axios from 'axios/index';
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {Container, Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';
import {httpConfig} from "../../shared/utils/http-config";
import {FormDebugger} from "../../shared/components/FormDebugger";
import sightingcontent from "./sightingcontent";

export const Sighting = () => {
	let Sighting = {
		sightingBirdPhoto: "",
		sightingDate: "",
		sightingTime: "",
		sightingLocX: "",
		sightingLocY: "",
	};
	const validator = Yup.object().shape({
		sightingBirdPhoto: Yup.string()
			.url("Must be valid URL.")
			.required ("You must upload a photo."),
		sightingDate: Yup.string()
			.required("You must include a valid date."),
		sightingTime: Yup.string()
			.required("You must include a valid time."),
		sightingLocX: Yup.number()
			.required("You must include a valid latitude."),
		sightingLocY: Yup.number()
			.required("You must include a valid longitude."),
	})
	const submitSighting = (values, {resetForm}) => {
		httpConfig.post("/apis/sighting/", values)
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200) {
					resetForm();
				}
			})
	}

	return (

		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{sightingcontent}
		</Formik>
	)
};


