import React from 'react';
import {Button, Form, FormControl, FormLabel} from 'react-bootstrap';
import InputGroup from "react-bootstrap/InputGroup";


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
			<Form.Group onSubmit={handleSubmit}>
				<Form.Group>
					<Form.Label>Email address</Form.Label>
					<Form.Control
						id="userProfileEmail"
						onChange={handleChange}
						name="userProfileEmail"
						onBlur={handleBlur}
						type="email"
						value={values.userProfileEmail}
						placeholder="Enter email"
					/>
					{
						errors.userProfileEmail && touched.userProfileEmail&& (
							<div className="alert alert-danger">
								{errors.userProfileEmail}
							</div>
						)
					}
				</Form.Group>

				<Form.Group>
					<Form.Label>Password</Form.Label>
					<Form.Control
						name="userProfilePassword"
						onChange={handleChange}
						onBlur={handleBlur}
						type="password"
						placeholder="Password"
						value={values.userProfilePassword}
					/>
					{
						errors.userProfilePassword && touched.userProfilePassword&& (
							<div className="alert alert-danger">
								{errors.userProfilePassword}
							</div>
						)
					}
				</Form.Group>
				{errors.userProfilePassword && touched.userProfilePassword && (
					<div className="alert alert-danger">{errors.userProfilePassword}</div>
				)}
				<Button type="submit">
					Sign In
				</Button>
				<span className="ml-3">Need an account?  <a href="/sign-up">Sign Up!</a></span>
			</Form.Group>
		</>
	);
};

export default LogInFormContent;