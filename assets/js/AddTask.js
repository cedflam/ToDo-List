import React, {Fragment} from 'react';
import ReactDOM from 'react-dom';
import '../css/AddTask.css';

const AddTask = () => {
    return (
        <Fragment>
            <form className="form-group" >
                <label htmlFor="titre">Titre</label>
                <input type="text" className="form-control " placeholder="Saisir le titre ..."/>
                <label htmlFor="description" className="mt-3">Description de la tâche</label>
                <textarea className="form-control"
                          name="description"
                          id=""
                          cols="30"
                          rows="5"
                          wrap="hard"
                          autoFocus="autofocus"/>

                <button type="submit"
                        className="btn btn-sm btn-primary mt-2">
                    Ajouter
                </button>
            </form>
        </Fragment>
    );
};

const rootElement = document.querySelector('#addTask');
ReactDOM.render(<AddTask/>, rootElement);
