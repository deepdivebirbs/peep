import React from 'react';
import {Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';

export const SignUpForm = () => {
	return (
		/*<Form noValidate validated={validated} onSubmit={handleSubmit}>*/
		<Form>
			<Form.Row>
				<Form.Group as={Col} md="4" controlId="validationFirstName">
					<Form.Label>First name</Form.Label>
					<Form.Control
						required
						type="text"
						placeholder="First name"
						defaultValue="Mark"
					/>
					<Form.Control.Feedback>Looks good!</Form.Control.Feedback>
				</Form.Group>
				<Form.Group as={Col} md="4" controlId="validationLastName">
					<Form.Label>Last name</Form.Label>
					<Form.Control
						required
						type="text"
						placeholder="Last name"
						defaultValue="Otto"
					/>
					<Form.Control.Feedback>Looks good!</Form.Control.Feedback>
				</Form.Group>
				<Form.Group as={Col} md="4" controlId="validationUsername">
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
				<Form.Group as={Col} md="6" controlId="validationEmail">
					<Form.Label>Email</Form.Label>
					<Form.Control type="text" placeholder="Email" required/>
					<Form.Control.Feedback type="invalid">
						Please enter an email address.
					</Form.Control.Feedback>
				</Form.Group>
				<Form.Group as={Col} md="3" controlId="validationCustom04">
					<Form.Label>Password</Form.Label>
					<Form.Control type="text" placeholder="Password" required/>
					<Form.Control.Feedback type="invalid">
						Please provide a valid state.
					</Form.Control.Feedback>
				</Form.Group>
			</Form.Row>
			<Form.Group>
				<Form.Check
					required
					label="Agree to terms and conditions"
					feedback="You must agree before submitting."
				/>
			</Form.Group>
			<Button type="submit">Submit form</Button>
		</Form>
	);
};

export default SignUpForm;