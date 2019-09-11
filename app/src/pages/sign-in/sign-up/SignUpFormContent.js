import React from 'react';

import {Container, Col, InputGroup, Form, Button} from 'react-bootstrap';

export const SignUpFormContent = (props) => {

	const {
		status,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset
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
								type="text"
								value={values.userFirstName}
								placeholder="First name"
								onChange={handleChange}
								onBlur={handleBlur}
								defaultValue="Mark"
							/>
							{
								errors.userFirstName && touched.userFirstName && (
									<div className="alert alert-danger">
										{errors.userFirstName}
									</div>
								)
							}
						</Form.Group>
						<Form.Group as={Col} md="4">
							<Form.Label>Last name</Form.Label>
							<Form.Control
								name="userLastName"
								type="text"
								value={values.userLastName}
								placeholder="Last name"
								onChange={handleChange}
								onBlur={handleBlur}
								defaultValue="Otto"
							/>
							{
								errors.userLastName && touched.userLastName && (
									<div className="alert alert-danger">
										{errors.userLastName}
									</div>
								)
							}
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
								/>
								{
									errors.profileUsername && touched.profileUsername && (
										<div className="alert alert-danger">
											{errors.profileUsername}
										</div>
									)
								}
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
							/>
							{
								errors.userProfileEmail && touched.userProfileEmail && (
									<div className="alert alert-danger">
										{errors.userProfileEmail}
									</div>
								)
							}
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
							/>
							{
								errors.userProfilePassword && touched.userProfilePassword && (
									<div className="alert alert-danger">
										{errors.userProfilePassword}
									</div>
								)
							}
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
							/>
							{
								errors.userProfilePasswordConfirm && touched.userProfilePasswordConfirm && (
									<div className="alert alert-danger">
										{errors.userProfilePasswordConfirm}
									</div>
								)
							}
						</Form.Group>
					</Form.Row>
					<Button variant="outline-primary" className="btn" type="submit">Sign Up</Button>
				</Form>
				{status && (<div className={status.type}>{status.message}</div>)}
			</Container>
		</>
	);
};

export default SignUpFormContent;