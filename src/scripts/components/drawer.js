document.addEventListener('DOMContentLoaded', initializeDrawer);

function initializeDrawer() {
	const BODY = document.body;
	const BUTTON_SELECTOR = '[data-drawer-open], [data-drawer-close], [data-drawer-toggle]';
	const DRAWER_STATES = {
		OPEN: 'visible',
		CLOSED: ''
	};

	// Handle button click events for the drawer actions.
	function handleButtonClick(event) {
		const targetButton = event.target;
		const actionType = getActionType(targetButton);

		if (!actionType) return;

		const targetId = targetButton.getAttribute(`data-${actionType}`);
		const targetElement = document.getElementById(targetId);
		const backdropElement = document.querySelector('.backdrop');

		toggleDrawer(actionType, targetElement, backdropElement);
	}

	// Determine the action type based on the clicked button.
	function getActionType(button) {
		if (button.hasAttribute('data-drawer-open')) return 'drawer-open';
		if (button.hasAttribute('data-drawer-close')) return 'drawer-close';
		if (button.hasAttribute('data-drawer-toggle')) return 'drawer-toggle';
		return null;
	}

	// Toggle the drawer based on the action type.
	function toggleDrawer(actionType, targetElement, backdropElement) {
		switch (actionType) {
			case 'drawer-open':
				setElementState(targetElement, DRAWER_STATES.OPEN);
				setElementState(backdropElement, DRAWER_STATES.OPEN);
				disableBodyScroll();  // Disable body scrolling when the drawer is open.
				break;

			case 'drawer-close':
				setElementState(targetElement, DRAWER_STATES.CLOSED);
				setElementState(backdropElement, DRAWER_STATES.CLOSED);
				enableBodyScroll();   // Enable body scrolling when the drawer is closed.
				break;

			case 'drawer-toggle':
				toggleElementState(targetElement, DRAWER_STATES.OPEN);
				toggleElementState(backdropElement, DRAWER_STATES.OPEN);
				toggleBodyScroll();   // Toggle body scrolling based on the current state.
				break;
		}
	}

	// Set the state attribute of an element.
	function setElementState(element, state) {
		if (element) element.dataset.state = state;
	}

	// Toggle the state attribute of an element.
	function toggleElementState(element, state) {
		if (element) {
			element.dataset.state = (element.dataset.state === state) ? DRAWER_STATES.CLOSED : state;
		}
	}

	// Disable body scrolling.
	function disableBodyScroll() {
		BODY.style.overflow = 'hidden';
	}

	// Enable body scrolling.
	function enableBodyScroll() {
		BODY.style.overflow = '';
	}

	// Toggle body scrolling based on its current state.
	function toggleBodyScroll() {
		BODY.style.overflow = (BODY.style.overflow === 'hidden') ? '' : 'hidden';
	}

	// Attach click event listeners to the drawer action buttons.
	document.querySelectorAll(BUTTON_SELECTOR).forEach(button => {
		button.addEventListener('click', handleButtonClick);
	});
}
