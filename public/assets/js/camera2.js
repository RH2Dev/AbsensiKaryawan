feather.replace();

const controls = document.querySelector('.controls');
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
const screenshotImage = document.querySelector('.screenshot-image');
const inputPhoto = document.querySelector('.data-photo');
const buttons = [...controls.querySelectorAll('button')];

const [screenshot] = buttons;

const constraints = {
  video: {
    width: {
      min: 1280,
      ideal: 1920,
      max: 2560,
    },
    height: {
      min: 720,
      ideal: 1080,
      max: 1440,
    },
  },
};

const getCameraSelection = async () => {
  const devices = await navigator.mediaDevices.enumerateDevices();
  const videoDevices = devices.filter(device => device.kind === 'videoinput');

  const updatedConstraints = {
    ...constraints,
    deviceId: {
      exact: videoDevices.deviceId,
    },
  };
  startStream(updatedConstraints);
};

const doScreenshot = () => {
  navigator.geolocation.getCurrentPosition(showPosition);

  function showPosition(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    screenshotImage.src = canvas.toDataURL('image/webp');
    inputPhoto.value = canvas.toDataURL('image/webp');
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    document.getElementById('absen').submit();
  }
};

screenshot.onclick = doScreenshot;

const startStream = async constraints => {
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleStream(stream);
};

const handleStream = stream => {
  video.srcObject = stream;
};

const streamStarted = true;

getCameraSelection();
