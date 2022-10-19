import React from 'react';

const Todo = (props) => {
    return (
        <div ref={props.innerRef} className="card mb-3 m-auto" {...props}>
            <div className="card-body d-flex justify-content-between align-items-center">
                <h5 className="card-title d-inline-block me-2">{props.name}</h5>
                <div>
                    <a href="#" className="d-inline-block btn btn-primary me-2">Update</a>
                    <a href="#" className="d-inline-block btn btn-danger">Remove</a>
                </div>
            </div>
        </div>
    );
};

export {Todo};