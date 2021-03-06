import { Resource } from 'scalar';
import ModalService from '../services/Modal';
import FormService from '../services/Form';
import Search from './search';

const location = window.location;
const queryParams = {};

function sendRequest($) {
  $.loading = true;
  new Resource(location.href).get()
  .then((data) => {
    const { page } = data;
    const disabledNext = (page + 1) * data.size >= data.total;
    const disabledPrev = page == 0;
    const name = $.name || 'page';
    $[$.nameData || 'data'] = data.result;
    $[$.nameNext || 'next'] = {
      disabled: disabledNext,
      href: disabledNext ? '' : getHref(page, page + 1, name)
    };
    $[$.namePrev || 'prev'] = {
      disabled: disabledPrev,
      href: disabledPrev ? '' : getHref(page, page - 1, name)
    };
    Object.assign($, getQueryParams($));
    Object.assign($, data);
    $.loading = false;
  });
}

function getPage(name) {
  const regex = new RegExp(name + '=(\\d+)');
  const page = location.search.match(regex);
  return page ? parseInt(page[1]) : 0;
}

function getHref(page, nextPage, name) {
  let { href } = location;
  if (nextPage > 0) {
    if (page) {
      href = href.replace(name + '=' + page, name + '=' + nextPage);
    } else {
      href += (href.indexOf('?') !== -1 ? '&' : '?') + name + '=' + nextPage;
    }
  } else {
    href = href
      .replace('?' + name + '=' + page, '')
      .replace('&' + name + '=' + page, '');
  }
  return href;
}

function addPage($, pagePlus) {
  const name = $.name || 'page';
  const page = getPage(name);
  const nextPage = page + pagePlus;
  if (page > nextPage && $[$.namePrev || 'prev'].disabled) return;
  if (page < nextPage && $[$.nameNext || 'next'].disabled) return;
  const href = getHref(page, nextPage, name);
  window.history.pushState(null, '', href);
  sendRequest($);
}

function setPage($, $element) {
  window.history.pushState(null, '', $element.href);
  sendRequest($);
}

function openModal(e, $) {
  const target = e.currentTarget;
  const _modal = $.inject(ModalService);
  _modal.open(target.form.dataset.modal, target.title).then(() => {
    $.compose(_modal.modal.$dom, Search)
    .send(getQueryParams($)).then((res) => {
      $.inject(FormService).setQueryString(res);
      sendRequest($);
    });
  });
}

function init($, options) {
  if (options) {
    Object.assign($, JSON.parse('{' + options + '}'));
  }
  const prev = $[$.namePrev || 'prev'];
  const next = $[$.nameNext || 'next'];
  const { href } = location;
  window.addEventListener('popstate', () => sendRequest($));
  prev.disabled = prev.disabled || href === prev.href;
  next.disabled = next.disabled || href === next.href;
  getQueryParams($);
}

function search(form, $) {
  if (!$.loading) {
    const _form = $.inject(FormService);
    const data = _form.toObject(form);
    _form.setQueryString(data);
    sendRequest($);
  }
}

function getQueryParams($) {
  const res = $.inject(FormService).getQueryParams(location.search);
  for (const key in queryParams) {
    queryParams[key] = '';
  }
  return Object.assign(queryParams, res);
}

export default ($) => ({
  mount: (e) => init($, e.target.dataset.options),
  'form': { _submit: (e) => search(e.target, $) },
  '.prev': { _click: () => addPage($, -1) },
  '.next': { _click: () => addPage($, 1) },
  '.modal': { _click: (e) => openModal(e, $) },
  'input[type="search"]': { _search: (e) => search(e.target.form, $) },
  '.num-page': { _click: (e) => setPage($, e.target) }
});
