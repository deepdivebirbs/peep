import React from 'react';
import {Row} from 'react-bootstrap';
import ViewBirdColumns from './ViewBirdColumns';

export const ViewBirdPage = () => {
	return (
		<>
			<Row>
				<ViewBirdColumns/>
			</Row>
		</>
	);
};

export default ViewBirdPage;