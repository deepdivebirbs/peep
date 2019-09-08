import React, {useState} from 'react';
import axios from 'axios/index';
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {Container, Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';
import {httpConfig} from "../../shared/utils/http-config";
import {FormDebugger} from "../../shared/components/FormDebugger";

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
						<Form.Group as={Col} md="4">
							<Form.Label>First name</Form.Label>
							<Form.Control
								name="userFirstName"
								required
								type="text"
								value={values.userFirstName}
								placeholder="First name"
								onChange={handleChange}
								onBlur={handleBlur}
								defaultValue="Mark"
							/>
							<Form.Control.Feedback>Looks good!</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="4">
							<Form.Label>Last name</Form.Label>
							<Form.Control
								name="userLastName"
								required
								type="text"
								value={values.userLastName}
								placeholder="Last name"
								onChange={handleChange}
								onBlur={handleBlur}
								defaultValue="Otto"
							/>
							<Form.Control.Feedback>Looks good!</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="4">
							<Form.Label>Username</Form.Label>
							<InputGroup>
								<Form.Control
									name="profileUsername"
									type="text"
									value={values.profileUsername}
									placeholder="Username"
									onChange={handleChange}
									onBlur={handleBlur}
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
						<Form.Group as={Col} md="6">
							<Form.Label>Email</Form.Label>
							<Form.Control
								name="userProfileEmail"
								type="text"
								value={values.userProfileEmail}
								placeholder="Email"
								onChange={handleChange}
								onBlur={handleBlur}
								required
							/>
							<Form.Control.Feedback type="invalid">
								Please provide a valid email.
							</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="3">
							<Form.Label>Password</Form.Label>
							<Form.Control
								name="userProfilePassword"
								type="password"
								value={values.userProfilePassword}
								placeholder="Password"
								onChange={handleChange}
								onBlur={handleBlur}
								required
							/>
							<Form.Control.Feedback type="invalid">
								Please provide a valid password.
							</Form.Control.Feedback>
						</Form.Group>
						<Form.Group as={Col} md="3">
							<Form.Label>Password Confirmation</Form.Label>
							<Form.Control
								name="userProfilePasswordConfirm"
								type="password"
								value={values.userProfilePasswordConfirm}
								placeholder="Password Confirmation"
								onChange={handleChange}
								onBlur={handleBlur}
								required
							/>
							<Form.Control.Feedback type="invalid">
								Please provide a valid password.
							</Form.Control.Feedback>
						</Form.Group>
					</Form.Row>
					<Button type="submit">Sign Up</Button>
					<FormDebugger {...props}/>
				</Form>
			</Container>
		</>
	);
};

export default SignUpFormContent;