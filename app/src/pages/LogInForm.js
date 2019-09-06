import React from 'react';
import {Button, Form, FormControl} from 'react-bootstrap';
import axios from 'axios';

export const LogInForm = () => {
	return (
		<>
			<Form>
				<Form.Group controlId="logInEmail">
					<Form.Label>Email address</Form.Label>
					<Form.Control type="email" placeholder="Enter email"/>
					<Form.Text className="text-muted">
						We'll never share your email with anyone else.
					</Form.Text>
				</Form.Group>

				<Form.Group controlId="logInPassword">
					<Form.Label>Password</Form.Label>
					<Form.Control type="password" placeholder="Password"/>
				</Form.Group>
				<Button variant="primary" type="submit">
					Submit
				</Button>
				<span className="ml-3">Need and account?  <a href="/sign-up">Sign Up!</a></span>
			</Form>
		</>
	);
};

export default LogInForm;