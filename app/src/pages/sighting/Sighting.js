import React, {useState} from 'react';
import axios from 'axios/index';
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {Container, Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';
import {httpConfig} from "../../shared/utils/http-config";
import {FormDebugger} from "../../shared/components/FormDebugger";
import sightingcontent from "./sightingcontent";

export const Sighting = () => {
	let values = {
		speciesComName: "",
		speciesSciName: "",
		sightingBirdPhoto: "",
		sightingDate: "",
		sightingTime: "",
		sightingLocation: "",
	};

	const validator = Yup.object().shape({
		sightingBirdPhoto: Yup.string()
			.url("Must be valid URL.")
			.required ("You must upload a photo."),
		speciesComName: Yup.string()
			.required("You must include a bird name"),
		speciesSciName: Yup.string()
			.required("You must include a bird science name"),
		sightingDate: Yup.string()
			.required("You must include a valid date."),
		sightingTime: Yup.string()
			.required("You must include a valid time."),
		sightingLocation: Yup.string()
			.required("You must include a valid latitude."),
	});
	const submitSighting = (values, {resetForm}) => {
		httpConfig.post("/apis/sighting/", values)
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200) {
					resetForm();
				}
			})
	};

	return (

		<Formik
			initialValues={values}
			onSubmit={submitSighting}
			validationSchema={validator}
		>
			{sightingcontent}
		</Formik>
	)
};


