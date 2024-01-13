import math

def sieve_of_eratosthenes(limit):
    primes = []
    is_prime = [True] * (limit + 1)
    is_prime[0] = is_prime[1] = False

    for num in range(2, int(math.sqrt(limit)) + 1):
        if is_prime[num]:
            primes.append(num)
            for multiple in range(num * num, limit + 1, num):
                is_prime[multiple] = False

    for num in range(math.isqrt(limit) + 1, limit + 1):
        if is_prime[num]:
            primes.append(num)

    return primes

def save_to_file(primes):
    with open("prime_numbers2.txt", "w") as file:
        for prime in primes:
            file.write(str(prime) + "\n")

try:
    # Read the last processed prime number from a file
    with open("prime_numbers2.txt", "r") as file:
        primes = [int(prime) for prime in file.read().split()]
except FileNotFoundError:
    primes = []

try:
    while True:
        if not primes:
            num1 = 2
        else:
            num1 = primes[-1] + 1

        new_primes = sieve_of_eratosthenes(num1 + 10000)  # Adjust the limit as needed

        for prime in new_primes:
            if prime > num1:
                primes.append(prime)
                print(prime, "is prime")

except KeyboardInterrupt:
    print("\nScript interrupted. Saving current state to file.")
    save_to_file(primes)
    print("File saved. Exiting.")
