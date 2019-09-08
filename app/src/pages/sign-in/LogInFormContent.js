import React from 'react';
import {Button, Form, FormControl} from 'react-bootstrap';

export const LogInForm = (props) => {
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
			<Form onSubmit={handleSubmit}>
				<Form.Group>
					<Form.Label>Email address</Form.Label>
					<Form.Control
						required
						name="userProfileEmail"
						type="email"
						value={values.userProfileEmail}
						onChange={handleChange}
						onBlur={handleBlur}
						placeholder="Enter email"
					/>
					<Form.Text className="text-muted">
						We'll never share your email with anyone else.
					</Form.Text>
				</Form.Group>

				<Form.Group>
					<Form.Label>Password</Form.Label>
					<Form.Control
						required
						name="userProfilePassword"
						type="password"
						value={values.userProfilePassword}
						onChange={handleChange}
						onBlur={handleBlur}
						placeholder="Password"
					/>
				</Form.Group>
				{errors.userProfilePassword && touched.userProfilePassword && (
					<div className="alert alert-danger">{errors.userProfilePassword}</div>
				)}
				<Button type="submit">
					Sign In
				</Button>
				<span className="ml-3">Need and account?  <a href="/sign-up">Sign Up!</a></span>
			</Form>
		</>
	);
};

export default LogInForm;