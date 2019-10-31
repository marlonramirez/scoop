import { Module } from 'scalar';
import Messenger from './scoop/services/Messenger';
import Form from './scoop/services/Form';
import messageComponent from './scoop/components/message';
import formComponent from './scoop/components/form';
import printerComponent from './scoop/components/printer';
import pageableComponent from './scoop/components/pageable';

new Module(
    Messenger,
    Form
).compose('#msg', messageComponent)
.compose('.scoop-form', formComponent)
.compose('.printer', printerComponent)
.compose('.pageable', pageableComponent);
