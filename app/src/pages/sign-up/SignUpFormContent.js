import React, {useState} from 'react';
import axios from 'axios/index';
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {Container, Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';
import {httpConfig} from "../../shared/utils/http-config";

export const SignUpFormContent = (props) => {

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
				<Form onSubmit={handleSubmit}>
					<Form.Row>
						<Form.Group as={Col} md="4" controlId="validationCustom01">
							<Form.Label>First name</Form.Label>
							<Form.Control
								required
								type="text"
								placeholder="First name"
								defaultValue="Mark"
							/>
							<Form.Control.Feedback>Looks good!</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="4" controlId="validationCustom02">
							<Form.Label>Last name</Form.Label>
							<Form.Control
								required
								type="text"
								placeholder="Last name"
								defaultValue="Otto"
							/>
							<Form.Control.Feedback>Looks good!</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="4" controlId="validationCustomUsername">
							<Form.Label>Username</Form.Label>
							<InputGroup>
								<Form.Control
									type="text"
									placeholder="Username"
									aria-describedby="inputGroupPrepend"
									required
								/>
								<Form.Control.Feedback type="invalid">
									Please choose a username.
								</Form.Control.Feedback>
							</InputGroup>
						</Form.Group>
					</Form.Row>
					<Form.Row>
						<Form.Group as={Col} md="6" controlId="validateEmail">
							<Form.Label>Email</Form.Label>
							<Form.Control type="text" placeholder="Email" required/>
							<Form.Control.Feedback type="invalid">
								Please provide a valid email.
							</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="3" controlId="validationPassword">
							<Form.Label>Password</Form.Label>
							<Form.Control type="password" placeholder="Password" required/>
							<Form.Control.Feedback type="invalid">
								Please provide a valid password.
							</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="3" controlId="validationPassword">
							<Form.Label>Password Confirmation</Form.Label>
							<Form.Control type="password" placeholder="Password Confirmation" required/>
							<Form.Control.Feedback type="invalid">
								Please provide a valid password.
							</Form.Control.Feedback>
						</Form.Group>
					</Form.Row>
					<Button type="submit">Sign Up</Button>
				</Form>
			</Container>
		</>
	);
};

export default SignUpFormContent;