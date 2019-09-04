import React from 'react';
import {Button, Form, FormControl} from 'react-bootstrap';

export const LogInForm = () => {
	return (
		<>
			<Form>
				<Form.Group controlId="formBasicEmail">
					<Form.Label>Email address</Form.Label>
					<Form.Control type="email" placeholder="Enter email"/>
					<Form.Text className="text-muted">
						We'll never share your email with anyone else.
					</Form.Text>
				</Form.Group>

				<Form.Group controlId="formBasicPassword">
					<Form.Label>Password</Form.Label>
					<Form.Control type="password" placeholder="Password"/>
					<a href="#">Need help signing in?</a>
				</Form.Group>
				<Form.Group controlId="formBasicCheckbox">
					<Form.Check type="checkbox" label="Check me out"/>
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