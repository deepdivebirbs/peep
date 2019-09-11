import React from 'react';
import {Row} from 'react-bootstrap';
import ViewBirdColumns from './ViewBirdColumns';

export const ViewBirdPage = () => {
	return (
		<>
			<h1 className="view-species-header text-center">View Species</h1>
			<Row className="text-center">
				<ViewBirdColumns/>
			</Row>
		</>
	);
};

export default ViewBirdPage;