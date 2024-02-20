module.exports = {
  verbose: true,
  testEnvironment: 'jsdom',
  moduleFileExtensions: ['ts', 'tsx', 'js', 'json'],
  moduleNameMapper: {
    '\\.scss$': 'identity-obj-proxy',
    '^@/(.*)$': '<rootDir>/src/$1',
  },
  collectCoverageFrom: ['<rootDir>/src/**/*.{ts, tsx}'],
  roots: ['<rootDir>/src'],
  testRegex: '(/tests/.*|(\\.|/)(test|spec))\\.(ts|tsx)$',
  transform: {
    '^.+\\.(ts|tsx)$': [
      'ts-jest',
      {tsconfig: './tsconfig.json'},
    ]
  },
};
