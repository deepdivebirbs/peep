import React from 'react';
import {Link} from "react-router-dom";
import {Button, Form, FormControl, FormLabel} from 'react-bootstrap';
import InputGroup from "react-bootstrap/InputGroup";
import LogInModal from './LogInModal';


export const LogInFormContent = (props) => {
	const {
		status,
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
					<InputGroup>
						<Form.Control
							id="userProfileEmail"
							onChange={handleChange}
							onBlur={handleBlur}
							name="userProfileEmail"
							type="email"
							value={values.userProfileEmail}
							placeholder="Enter email"
						/>
					</InputGroup>
					{
						errors.userProfileEmail && touched.userProfileEmail && (
							<div className="alert alert-danger">
								{errors.userProfileEmail}
							</div>
						)
					}

				</Form.Group>

				<Form.Group>
					<Form.Label>Password</Form.Label>
					<InputGroup>
						<Form.Control
							id="userProfilePassword"
							name="userProfilePassword"
							onChange={handleChange}
							onBlur={handleBlur}
							type="password"
							placeholder="Password"
							value={values.userProfilePassword}
						/>
					</InputGroup>
					{
						errors.userProfilePassword && touched.userProfilePassword && (
							<div className="alert alert-danger">
								{errors.userProfilePassword}
							</div>
						)
					}
				</Form.Group>

				<Form.Group>
					<Button variant="primary" type="submit" href="/">
						Sign In
					</Button>
					<span className="ml-3">Need an account?  <a href="/Sign-up">Sign Up!</a></span>
				</Form.Group>
			</Form>

			{status && (<div className={status.type}>{status.message}</div>)}
		</>
	);
};

export default LogInFormContent;