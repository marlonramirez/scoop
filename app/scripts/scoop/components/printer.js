function getFrame() {
  let frame = document.getElementById('frame-scoop-ajax');
  if (frame) return frame;
  frame = document.createElement('iframe');
  frame.style.display = 'none';
  frame.name = 'frame-scoop-ajax';
  frame.id = 'frame-scoop-ajax';
  document.body.appendChild(frame);
  return frame;
}

function sendRequest(e) {
  const link = e.target;
  const frame = getFrame();
  link.target = 'frame-scoop-ajax';
  frame.onload = () => {
    const content = frame.contentWindow || frame.contentDocument;
    content.print();
  };
}

export default () => ({
    click: sendRequest
});
