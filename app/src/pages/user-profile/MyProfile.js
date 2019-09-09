import React from 'react';
import httpConfig from '../../../../app/src/shared/utils/http-config'
import {Container} from 'react-bootstrap';

export const MyProfile = () => {
	httpConfig.get()
	return (
		<>
			<Container>
				<h1>My Profile</h1>
				<div>
					<span>Username:</span>
					<p>Username Placeholder</p>
					<span>First Name:</span>
					<p>First Name Placeholder</p>
					<span>Last Name:</span>
					<p>Last Name Placeholder</p>
					<span>Email:</span>
					<p>Email Placeholder</p>
				</div>
			</Container>
		</>
	);
};

export default MyProfile;