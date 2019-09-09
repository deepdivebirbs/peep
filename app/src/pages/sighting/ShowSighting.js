import React from 'react';
import httpConfig from '../../../../app/src/shared/utils/http-config';

export const ShowSighting = () => {
	return (
		<>
			<Container>
				<h1>Sighting</h1>
				<div>
					<p>Photo</p>
				</div>
				<div>
					<p>Common Name</p>
				</div>
				<div>
					<p>Scientific Name</p>
				</div>
				<div>
					<p>Date</p>
				</div>
				<div>
					<p>Time</p>
				</div>
				<div>
					<p>Location</p>
				</div>
			</Container>
		</>
	);
}

