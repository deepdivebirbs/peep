import React, {useState} from 'react';
import axios from 'axios/index';
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {Container, Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';
import {httpConfig} from "../../shared/utils/http-config";

export const AddSighting = (props) => {
	const {
		submitStatus,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset,
		validated
	} = props;

	return (
		<>
			<Container>
				<Form>
					<Form.Row>
						<Form.Group as={Col}></Form.Group>
						<Form.Group as={Col}>
							<Button className={"btn btn-primary"} type="submit">Upload a Bird Photo</Button>
						</Form.Group>
						<Form.Group as={Col}></Form.Group>
					</Form.Row>


					<Form.Row>
						<Form.Group as={Col}>
							<Form.Label>Common Name</Form.Label>
							<Form.Control
								type="text"
								placeholder="Search Common Name"
								required
								value={values.speciesComName}
								onChange={handleChange}
								onBlur={handleBlur}
							/>

						</Form.Group>

						<Form.Group as={Col}>
							<Form.Label>Scientific Name</Form.Label>
							<Form.Control
								type="text"
								placeholder="Search Scientific Name"
								required
								value={values.speciesSciName}
								onChange={handleChange}
								onBlur={handleBlur}
							/>
						</Form.Group>
					</Form.Row>

					<Form.Row>
						<Form.Group as={Col}>
							<Form.Label>Date</Form.Label>
							<Form.Control
								type="text"
								placeholder="Date"
								required
								value={values.sightingDate}
								onChange={handleChange}
								onBlur={handleBlur}
							/>
						</Form.Group>

						<Form.Group as={Col}>
							<Form.Label>Time</Form.Label>
							<Form.Control
								type="text"
								placeholder="Time"
								required
								value={values.sightingTime}
								onChange={handleChange}
								onBlur={handleBlur}
							/>
						</Form.Group>
					</Form.Row>

					<Form.Row>
						<Form.Group as={Col}>
							<Form.Label>Location</Form.Label>
							<Form.Control
								type="text"
								placeholder="Location"
								required
								value={values.sightingLocation}
								onChange={handleChange}
								onBlur={handleBlur}
							/>
						</Form.Group>
					</Form.Row>

					<Button variant="primary" type="submit">
						Submit
					</Button>
				</Form>
			</Container>
		</>
	);
};


export default AddSighting;