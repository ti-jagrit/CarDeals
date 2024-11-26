import numpy as np
import pandas as pd
from flask import Flask, request, jsonify


# Load and preprocess the data
def load_and_preprocess_data(filepath):
    df = pd.read_csv(filepath)

    # Clean up 'Mileage', 'Engine', and 'Power' columns by extracting numerical values
    df['Mileage'] = df['Mileage'].str.extract('(\d+.\d+)').astype(float)
    df['Engine'] = df['Engine'].str.extract('(\d+)').astype(float)
    df['Power'] = df['Power'].str.extract('(\d+.\d+)').astype(float)

    # Fill missing values with the median for numerical columns and mode for categorical columns
    df['Mileage'].fillna(df['Mileage'].median(), inplace=True)
    df['Engine'].fillna(df['Engine'].median(), inplace=True)
    df['Power'].fillna(df['Power'].median(), inplace=True)
    df['Seats'].fillna(df['Seats'].mode()[0], inplace=True)

    # Drop rows with missing target values 'Price'
    df = df.dropna(subset=['Price'])

    # Convert categorical variables into numerical format using one-hot encoding
    df = pd.get_dummies(df, columns=['Fuel_Type', 'Transmission', 'Owner_Type'], drop_first=True)

    # Drop the 'S.No.' and 'Name' columns as they are not useful for prediction
    df = df.drop(columns=['S.No.', 'Name'])

    return df


# Function to calculate entropy
def entropy(y):
    unique, counts = np.unique(y, return_counts=True)
    probabilities = counts / len(y)
    return -np.sum(probabilities * np.log2(probabilities))


# Function to calculate information gain
def information_gain(X_column, y, split_threshold):
    parent_entropy = entropy(y)

    left_indices = np.where(X_column <= split_threshold)[0]
    right_indices = np.where(X_column > split_threshold)[0]

    if len(left_indices) == 0 or len(right_indices) == 0:
        return 0

    n = len(y)
    n_left, n_right = len(left_indices), len(right_indices)
    e_left, e_right = entropy(y[left_indices]), entropy(y[right_indices])
    weighted_entropy = (n_left / n) * e_left + (n_right / n) * e_right

    return parent_entropy - weighted_entropy


# Function to find the best split
def best_split(X, y):
    best_gain = -1
    best_feature, best_threshold = None, None

    for feature_index in range(X.shape[1]):
        X_column = X[:, feature_index]
        thresholds = np.unique(X_column)

        for threshold in thresholds:
            gain = information_gain(X_column, y, threshold)

            if gain > best_gain:
                best_gain = gain
                best_feature = feature_index
                best_threshold = threshold

    return best_feature, best_threshold


# Define the node structure
class DecisionNode:
    def __init__(self, feature=None, threshold=None, left=None, right=None, value=None):
        self.feature = feature
        self.threshold = threshold
        self.left = left
        self.right = right
        self.value = value


# Function to build the tree
def build_tree(X, y, depth=0, max_depth=10):
    num_samples, num_features = X.shape
    if depth == max_depth or num_samples <= 1:
        leaf_value = np.mean(y)
        return DecisionNode(value=leaf_value)

    feature, threshold = best_split(X, y)
    if feature is None:
        leaf_value = np.mean(y)
        return DecisionNode(value=leaf_value)

    left_indices = np.where(X[:, feature] <= threshold)[0]
    right_indices = np.where(X[:, feature] > threshold)[0]

    left_subtree = build_tree(X[left_indices, :], y[left_indices], depth + 1, max_depth)
    right_subtree = build_tree(X[right_indices, :], y[right_indices], depth + 1, max_depth)

    return DecisionNode(feature, threshold, left_subtree, right_subtree)


# Function to make predictions
def predict_tree(node, X):
    if node.value is not None:
        return node.value

    if X[node.feature] <= node.threshold:
        return predict_tree(node.left, X)
    else:
        return predict_tree(node.right, X)


# Load data and train the decision tree
def train_model(filepath):
    df = load_and_preprocess_data(filepath)
    X = df.drop(columns=['Price']).values
    y = df['Price'].values

    # Build and return the decision tree model
    return build_tree(X, y, max_depth=10)


# Create the Flask API
app = Flask(__name__)

# Load and train the model
model = train_model(r"nepal_car_price.csv")


@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    # Extract the features from the request
    features = np.array([data[col] for col in data.keys()])

    # Make a prediction using the decision tree model
    prediction = predict_tree(model, features)

    return jsonify({'predicted_price': prediction})


if __name__ == '__main__':
    app.run(debug=True)



    # http://localhost:5000/predict