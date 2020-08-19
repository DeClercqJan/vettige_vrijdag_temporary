export default function getLocalStorageItemIfExists(key, type) {
  if (localStorage.getItem(key)) {
    return JSON.parse(localStorage.getItem(key));
  }

  if (type === 'array') {
    return [];
  }
  if (type === 'string') {
    return '';
  }
  if (type === 'boolean') {
    return true;
  }
  if (type === 'object') {
    return {};
  }
  // add more types if needed
}
