describe('Main pages exist and openable', () => {
  it('Opens main page', () => {
    cy.visit('http://127.0.0.1:8000/')
    cy.title().should('eq',"Home Page")
    cy.get('#no_room_message').contains('There are no rooms added to the database!')
    //cy.screenshot()
  })
  it('Opens Settings Page ', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.title().should('eq',"Settings")
    cy.get('#no_room_message').contains('No room in the database!')
    //cy.screenshot()
  });
  it('Opens RFID Settings Page ', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.get('#rfid_settings').click()
    cy.title().should('eq',"RFID Settings")
    cy.get('#no_rfid_message').contains('No RFID reader in the database!')
    //cy.screenshot()
  });
  it('Opens RFID Use History Page ', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.get('#rfid_settings').click()
    cy.get('#rfid_use_history').click()
    cy.contains('RFID Use History').should('be.visible')
    cy.title().should('eq',"RFID Use History")
    //cy.screenshot()
  });
})
describe('Rooms - CRUD', () => {
  it('Adds a new room and deletes it, shows every function working (reset, cancel, submit) also checks room on main page', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.contains('Add Room')
    cy.get('#add_room').click()
    cy.contains('Add a New Room').should('be.visible')
    cy.get('#name').type('Test Room - Cypress')
    cy.get('#name').should('have.value','Test Room - Cypress')
    cy.get('#reset').click()
    cy.get('#name').should('have.value','')
    cy.get('#name').type('Test Room - Cypress')
    cy.get('#cancel').click()
    cy.title().should('eq',"Settings")
    cy.get('#add_room').click()
    cy.get('#name').type('TestRoom-Cypress')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully added a new room: TestRoom-Cypress')
    //----------
    cy.get('#back_to_main').click()
    cy.get('#room_name_TestRoom-Cypress').contains('TestRoom-Cypress')
    cy.get('#settings').click()
    //----------------------------------------------------------------------------
    //cy.screenshot()
    cy.get('#delete_room_TestRoom-Cypress').click()
    cy.get('#message').contains('Successfully deleted room: TestRoom-Cypress')
    //cy.screenshot()
  });
  it('Adds a room, modifies it,then deletes it.', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.title().should('eq',"Settings")
    cy.get('#add_room').click()
    cy.get('#name').type('TestRoom-Cypress')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully added a new room: TestRoom-Cypress')
    //cy.screenshot()
    //----------
    cy.contains('TestRoom-Cypress')
    cy.get('#modify_room_TestRoom-Cypress').click()
    cy.contains('Modify room: TestRoom-Cypress').should('be.visible')
    //cy.screenshot()
    cy.get('#name').clear()
    cy.get('#name').type('TestRoom-Cypress-Modified')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully updated room: TestRoom-Cypress-Modified')
    cy.contains('TestRoom-Cypress-Modified')
    //cy.screenshot()
    cy.get('#delete_room_TestRoom-Cypress-Modified').click()
    cy.get('#message').contains('Successfully deleted room: TestRoom-Cypress-Modified')
    //cy.screenshot()
  });
  it('Adds a room, then adds another with the same name -> expected error: "The name has already been taken."', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.title().should('eq',"Settings")
    cy.get('#add_room').click()
    cy.get('#name').type('TestRoom-Cypress-same')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully added a new room: TestRoom-Cypress-same')
    //cy.screenshot()
    cy.get('#add_room').click()
    cy.get('#name').type('TestRoom-Cypress-same')
    cy.get('#submit').click()
    cy.get('#error_message').contains('The name has already been taken.')
    cy.get('#cancel').click()
    cy.get('#delete_room_TestRoom-Cypress-same').click()
    cy.get('#message').contains('Successfully deleted room: TestRoom-Cypress-same')
  });
})
describe('Adds 3 rooms, 2 sensors for later use -> for device update/delete', function () {
  it('Adds 3 Rooms for later use', function () {
    cy.visit('http://127.0.0.1:8000/settings')
    cy.get('#add_room').click()
    cy.get('#name').type('TestRoom-Cypress-for-Devices')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully added a new room: TestRoom-Cypress-for-Devices')
    cy.get('#add_room').click()
    cy.get('#name').type('TestRoom-Cypress-for-Devices-2')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully added a new room: TestRoom-Cypress-for-Devices-2')
  });
  it('Adds 2 Sensors for later use (with different ip)', function () {
    cy.visit('http://127.0.0.1:8000/settings')
    cy.get('#add_device_TestRoom-Cypress-for-Devices').click()
    cy.contains(' Add device to TestRoom-Cypress-for-Devices').should('be.visible')
    cy.get('#name').type('Test-Device-1')
    cy.get('#type').select('Sensor')
    cy.get('#ip_End').type('20')
    cy.get('#submit').click()
    cy.get('#add_device_TestRoom-Cypress-for-Devices-2').click()
    cy.contains(' Add device to TestRoom-Cypress-for-Devices-2').should('be.visible')
    cy.get('#name').type('Test-Device-2')
    cy.get('#type').select('Sensor')
    cy.get('#ip_End').type('21')
    cy.get('#submit').click()
  });
});
describe('Devices (esp) - Add/Modify/Delete - with no errors', function () {
  it('Adds a device, modifies name and ip, and puts it to another room, then deletes it', function () {
    cy.visit('http://127.0.0.1:8000/settings')
    cy.get('#add_device_TestRoom-Cypress-for-Devices').click()
    cy.contains(' Add device to TestRoom-Cypress-for-Devices').should('be.visible')
    cy.get('#name').type('Test-Device-3')
    cy.get('#type').select('Toggle')
    cy.get('#ip_End').type('40')
    cy.get('#submit').click()
    //cy.screenshot()
    cy.get('#edit_device_Test-Device-3').click()
    cy.contains(' Modify Test-Device-3 in TestRoom-Cypress-for-Devices')
    cy.get('#deviceName').type('-Modified')
    cy.get('#ip_End').clear()
    cy.get('#ip_End').type('41')
    cy.get('#room').select('TestRoom-Cypress-for-Devices-2')
    cy.get('#submit').click()
    cy.get('#message').contains('Successfully updated Test-Device-3-Modified')
  });
});
describe('Devices (esp) - Add/Modify - with expected errors', function () {
  it('Tries to add another sensors to the same room -> expected error: "Rooms can only have 1 Sensor!"', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.title().should('eq','Settings')
    cy.get('#add_device_TestRoom-Cypress-for-Devices').click()
    cy.get('#name').type('Test-Device-same')
    cy.get('#type').select('Sensor')
    cy.get('#ip_End').type('50')
    cy.get('#submit').click()
    cy.get('#error_message').contains('Rooms can only have 1 Sensor!')
  });
  it('Tries to add 2 devices with same ip address -> expected error: "This ip end has been taken."', function () {
    cy.visit('http://127.0.0.1:8000/')
    cy.get('#settings').click()
    cy.title().should('eq','Settings')
    cy.get('#add_device_TestRoom-Cypress-for-Devices').click()
    cy.contains(' Add device to TestRoom-Cypress-for-Devices').should('be.visible')
    cy.get('#name').type('Test-Device')
    cy.get('#type').select('Toggle')
    cy.get('#ip_End').type('60')
    cy.get('#submit').click()
    cy.get('#add_device_TestRoom-Cypress-for-Devices').click()
    cy.contains(' Add device to TestRoom-Cypress-for-Devices').should('be.visible')
    cy.get('#name').type('Test-Device')
    cy.get('#type').select('Toggle')
    cy.get('#ip_End').type('60')
    cy.get('#submit').click()
    cy.get('#error_message').contains('The ip end has already been taken.')
    cy.get('#cancel').click()
    cy.get('#delete_device_Test-Device').click()
  });
  it('Tries to modifies ip to an an existing ip -> expected error: "The ip end has already been taken."', function () {
    cy.visit('http://127.0.0.1:8000/settings')
    cy.get('#edit_device_Test-Device-2').click()
    cy.get('#ip_End').clear()
    cy.get('#ip_End').type('20')
    cy.get('#submit').click()
    cy.get('#error_message').contains('The ip end has already been taken.')
  });
  it('Tries to move sensor to a room that already has a sensor -> expected error: "Rooms can only have 1 Sensor!"', function () {
    cy.visit('http://127.0.0.1:8000/settings')
    cy.get('#edit_device_Test-Device-2').click()
    cy.get('#room').select('TestRoom-Cypress-for-Devices')
    cy.get('#submit').click()
    cy.get('#error_message').contains('Rooms can only have 1 Sensor!')
  });
});
describe('Deteles 2 unused rooms after testing Device (esp) CRUD', function () {
  it('Deletes 2 unused rooms', function () {
    cy.visit('http://127.0.0.1:8000/settings')
    cy.get('#delete_room_TestRoom-Cypress-for-Devices').click()
    cy.get('#delete_room_TestRoom-Cypress-for-Devices-2').click()
  });
});

