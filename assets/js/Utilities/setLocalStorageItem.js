export default function setLocalStorageItem(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}
